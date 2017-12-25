package info.smartkit.elk.piwik.service;

import com.google.common.collect.Lists;

import info.smartkit.elk.piwik.dao.PiwikLogVisitDAO;
import info.smartkit.elk.piwik.domain.PiwikLogVisit;
import info.smartkit.elk.exception.ResourceNotFoundException;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Service;


import java.sql.SQLException;
import java.util.Collection;

@Service
public class PiwikLogVisitService {

    @Autowired
    private PiwikLogVisitDAO piwikLogVisitDAO;

    private static final Logger LOGGER = LoggerFactory.getLogger(PiwikLogVisitService.class);


    @Autowired
    private JdbcTemplate jdbcTemplate;

    public JSONArray getAllPiwikLogVisitsRaw() throws SQLException {
        //@see:https://piwik.org/faq/how-to/#faq_158
        String sql = "select idsite,idvisit,visit_last_action_time,user_id,inet_ntoa(conv(hex(location_ip), 16, 10)) as location_ip, conv(hex(idvisitor), 16, 10) as idvisitor from piwik_log_visit";
        SqlRowSet rows = jdbcTemplate.queryForRowSet(sql);
//        List<Object> ObjlistAll = new ArrayList<Object>();
        //
        JSONArray jsonArray = new JSONArray();
        while (rows.next()) {
            //
            int colCount = rows.getMetaData().getColumnCount();
//            List<Object> Objlist = new ArrayList<Object>();
            JSONObject jsonObject = new JSONObject();
            for (int i = 1; i <= colCount; i++) {
//                Objlist.add(rows.getObject(i));
                String column_name = rows.getMetaData().getColumnName(i);
                jsonObject.put(column_name, rows.getObject(column_name));
            }
            LOGGER.info(jsonObject.toJSONString());
            jsonArray.add(jsonObject);
//            ObjlistAll.add(Objlist);
        }

        return jsonArray;
    }

    /**
     * Allows to retrieve all existing users from the database.
     * Pagination is not implemented in order to keep it simple.
     *
     * @return the all existing {@link PiwikLogVisit} entities
     */
    public Collection<PiwikLogVisit> getAllPiwikLogVisits() {
        System.out.println("system.out.println:"+this.piwikLogVisitDAO.findAll());
        return Lists.newArrayList(this.piwikLogVisitDAO.findAll());
    }

    /**
     * Allows to get a user by the given user identifier.
     *
     * @param piwikLogVisitId the piwikLogVisit id
     * @return the {@link PiwikLogVisit}
     */
    public PiwikLogVisit getPiwikLogVisit(final Long piwikLogVisitId) {
        return findPiwikLogVisitOrThrowNotFoundException(piwikLogVisitId);
    }

    private PiwikLogVisit findPiwikLogVisitOrThrowNotFoundException(final Long piwikLogVisitId) {
        PiwikLogVisit piwikLogVisit = this.piwikLogVisitDAO.findOne(piwikLogVisitId);
        if (piwikLogVisit == null) {
            throw new ResourceNotFoundException(String.format("PiwikLogVisit %s not found", piwikLogVisit));
        }
        return piwikLogVisit;
    }
}
