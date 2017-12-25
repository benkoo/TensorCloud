package info.smartkit.elk.dao;

import info.smartkit.elk.domain.PiwikLogVisit;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PiwikLogVisitDAO extends CrudRepository<PiwikLogVisit,Long> {
}
