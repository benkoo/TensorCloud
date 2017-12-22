package com.vlotar.demo.piwik.controller;

import com.google.gson.Gson;
import com.vlotar.demo.piwik.response.PiwikLogVisitResponse;
import com.vlotar.demo.service.PiwikLogVisitService;
import com.vlotar.demo.service.converter.PiwikLogVisitConverter;

import io.swagger.annotations.Api;
import io.swagger.annotations.ApiOperation;
import io.swagger.annotations.ApiParam;
import net.logstash.logback.marker.Markers;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.sql.SQLException;
import java.util.stream.Collectors;

import static net.logstash.logback.marker.Markers.append;
import static net.logstash.logback.marker.Markers.appendRaw;


@Api(value = "/users", description = "API manages 'users' allowing to perform basic CRUD operations")
@RestController
@RequestMapping("/piwik/log/visit") class PiwikLogVisitController {

    private static final Logger LOGGER = LoggerFactory.getLogger(PiwikLogVisitController.class);

    @Autowired
    private PiwikLogVisitService piwikLogVisitService;

    @Autowired
    private PiwikLogVisitConverter converter;

    @ApiOperation(
            value = "Retrieve 'request' by Id",
            notes = "Allows to retrieve existing 'request' resource by its identifier",
            response = PiwikLogVisitResponse.class
    )
    @RequestMapping(value = "/{userId}", method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String getPiwikLogVisit(@ApiParam(value = "Unique 'request' identifier") @PathVariable final Long piwikLogVisitId) {
        LOGGER.debug("Trying to retrieve PiwikLogVisit by ID: " + piwikLogVisitId);
        return toJson(this.converter.convert(this.piwikLogVisitService.getPiwikLogVisit(piwikLogVisitId)));
    }

    @ApiOperation(
            value = "Retrieve all 'users'",
            notes = "Allows to retrieve all existing 'PiwikLogVisit'",
            response = PiwikLogVisitResponse.class,
            responseContainer = "Set"
    )
    @RequestMapping(method = RequestMethod.GET, produces = "application/json")
    @ResponseBody
    public String getAllPiwikLogVisits() throws SQLException {
        LOGGER.debug("Trying to retrieve all PiwikLogVisits");
//
        String rawString = piwikLogVisitService.getAllPiwikLogVisitsRaw();
        String jsonString = toJson(
                piwikLogVisitService.getAllPiwikLogVisits().stream()
                        .map(user -> this.converter.convert(user)).collect(Collectors.toSet()));
//        LOGGER.info(append("HeartbeatPiwik[]", "HeartbeatPiwik"), "HeartbeatPiwik details []", "HeartbeatPiwik[]");
        LOGGER.info(String.valueOf(appendRaw("PiwikJson", jsonString)));
        return jsonString;
    }

    private static String toJson(Object object) {
        return new Gson().toJson(object);
    }

}
